import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from 'styled-components';
import axios from 'axios';
import ProjectCard from '../Organisms/ProjectCard';
import FilterContainer from '../Organisms/FilterContainer';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';

const WrapperGrid = styled(Grid)`
  width: 100%;
`;

const ContainerGrid = styled(Grid)`
  max-width: 1954px;
  margin: auto;
`;

const ProjectListPage = () => {
  const [host, setHost] = useState('');
  const [searchLanguage, setSearchLanguage] = useState([]);
  const [searchPurpose, setSearchPurpose] = useState('');
  const [searchGender, setSearchGender] = useState('');
  const [projects, setProjects] = useState([]);
  const [filterResult, setFilterResult] = useState([]);

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
    let result = [];
    let search = false;

    projects.map((pj) => {
      if (searchLanguage.length > 0) {
        search = true;
        if (searchLanguage.includes(pj.language) || searchLanguage.includes(pj.sub_language)) result.push(pj);
      }
      if (searchPurpose !== 'すべて' && searchPurpose !== '') {
        search = true;
        if (searchPurpose === pj.purpose) result.push(pj);
      }
      if (searchGender !== '制限なし' && searchGender !== '') {
        search = true;
        if (searchGender === pj.men_and_women) result.push(pj);
      }
    });

    setFilterResult(search && result.length === 0 ? '該当なし' : Array.from(new Set(result)));
  }, [projects, searchLanguage, searchPurpose, searchGender]);

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
        {typeof filterResult === 'string' ? (
          <Typography>該当するプロジェクトがありません</Typography>
        ) : (
          filterResult.length > 0 ? (
            filterResult.map((project, index) => {
              return <ProjectCard item key={index} project_data={project} />;
            })
          ) : (
            projects.map((project, index) => {
              return <ProjectCard item key={index} project_data={project} />;
            })
          )
        )}
      </ContainerGrid>
    </WrapperGrid>
  );
};

export default ProjectListPage;

ReactDOM.render(<ProjectListPage />, document.getElementById('project_list'));
