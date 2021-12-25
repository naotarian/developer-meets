/* eslint no-unused-vars: 0 */
import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from 'styled-components';
import axios from 'axios';
import cloneDeep from 'lodash/cloneDeep';
import ProjectCard from '../Organisms/ProjectCard';
import FilterContainer from '../Organisms/FilterContainer';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';
import Pagination from '@mui/material/Pagination';

const WrapperGrid = styled(Grid)`
  width: 100%;
`;

const ContainerGrid = styled(Grid)`
  max-width: 1954px;
  margin: auto;
`;

const StyledPagination = styled(Pagination)`
  text-align: center;
  margin-top: 1rem;
  margin-bottom: 1rem;
  & ul {
    display: inline-flex;
    & button {
      outline: none;
    }
  }
`;

const ProjectListPage = () => {
  const [host, setHost] = useState('');
  const [search, setSearch] = useState(false);
  const [searchLanguage, setSearchLanguage] = useState([]);
  const [searchPurpose, setSearchPurpose] = useState('');
  const [searchGender, setSearchGender] = useState('');
  const [projects, setProjects] = useState([]);
  const [filterResult, setFilterResult] = useState([]);
  const [page, setPage] = useState(1);

  useEffect(() => {
    setHost(location.host);
  }, []);

  useEffect(() => {
    if (host) {
      let protocol = host === 'developer-meets.com' ? 'https' : 'http';
      let url = `${protocol}://${host}/api/all_projejct`;
      axios.get(url).then(res => {
        setProjects(res.data);
      });
    }
  }, [host]);

  useEffect(() => {
    let search = false;
    let copyLists = cloneDeep(projects);

    if (searchLanguage.length > 0) {
      search = true;
      copyLists.map((pj, index) => {
        if (searchLanguage.includes(pj.language) || searchLanguage.includes(pj.sub_language)) {
          // pass
        } else {
          copyLists.splice(index, 1, '');
        }
      });
    }

    if (searchPurpose !== 'すべて' && searchPurpose !== '') {
      search = true;
      copyLists.map((pj, index) => {
        if (searchPurpose !== pj.purpose) copyLists.splice(index, 1, '');
      });
    }

    if (searchGender !== '制限なし' && searchGender !== '') {
      search = true;
      copyLists.map((pj, index) => {
        if (searchGender !== pj.men_and_women) copyLists.splice(index, 1, '');
      });
    }

    let result = [];
    copyLists.map(pj => {
      if (typeof pj === 'object') result.push(pj);
    });
    setSearch(search);
    setFilterResult(Array.from(new Set(result)));
  }, [searchLanguage, searchPurpose, searchGender]);

  const sliceByNumber = (array) => {
    if (array.length === 0) { return []; }
    const max = 12;
    const length = Math.ceil(array.length / max);
    return new Array(length).fill().map((_, i) => array.slice(i * max, (i + 1) * max));
  };

  const handleChangePage = (event, value) => {
    setPage(value);
  };

  return (
    <WrapperGrid>
      <FilterContainer
        searchLanguage={searchLanguage}
        setSearchLanguage={(val) => setSearchLanguage(val)}
        searchPurpose={searchPurpose}
        setSearchPurpose={(val) => setSearchPurpose(val)}
        searchGender={searchGender}
        setSearchGender={(val) => setSearchGender(val)}
      />
      <ContainerGrid container justifyContent="center">
        {search ? (
          filterResult.length > 0 ? (
            sliceByNumber(filterResult)[page - 1].map((project, index) => {
              return <ProjectCard item key={index} data={project} />;
            })
          ) : (
            <Typography>該当するプロジェクトがありません</Typography>
          )
        ) : (
          projects.length > 0 && sliceByNumber(projects)[page - 1].map((project, index) => {
            return <ProjectCard item key={index} data={project} />;
          })
        )}
      </ContainerGrid>
      <StyledPagination count={sliceByNumber(projects).length} page={page} onChange={handleChangePage} />
    </WrapperGrid>
  );
};

export default ProjectListPage;

ReactDOM.render(<ProjectListPage />, document.getElementById('project_list'));
